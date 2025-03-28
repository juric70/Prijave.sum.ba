# Use the official Bun image for better performance
FROM oven/bun:latest AS base

# Set the working directory
WORKDIR /usr/src/app

# Copy package.json and bun.lock for dependency installation
COPY package.json bun.lock ./
RUN bun install --frozen-lockfile

# Copy the rest of the application code and build the Nuxt application
COPY . .
RUN bun run build

# Use a lightweight server image for production
FROM oven/bun:latest AS production

# Set the working directory
WORKDIR /usr/src/app

# Copy only the built application and necessary files
COPY --from=base /usr/src/app/node_modules ./node_modules
COPY --from=base /usr/src/app/.output ./.output
COPY --from=base /usr/src/app/.nuxt ./.nuxt
COPY --from=base /usr/src/app/public ./public
COPY --from=base /usr/src/app/package.json ./package.json
COPY --from=base /usr/src/app/bun.lock ./bun.lock
COPY --from=base /usr/src/app/nuxt.config.ts ./nuxt.config.ts
COPY --from=base /usr/src/app/tsconfig.json ./tsconfig.json

# Expose port 3000
EXPOSE 3000

# Run the application
CMD ["bun", "run", "preview"]